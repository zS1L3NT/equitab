import { useTheme } from "@react-navigation/native"
import { FlashList } from "@shopify/flash-list"
import React from "react"
import { View } from "react-native"
import AppListItem, { type AppListMeasurements, type AppListItemProps } from "./list-item"
import AppListItemShimmer from "./list-item-shimmer"

export type AppListProps = {
	items: (AppListItemProps | null)[]
	measurements: AppListMeasurements
	inset?: boolean
}

export default function AppList({ items, measurements, inset = false }: AppListProps) {
	const theme = useTheme()

	const INSET_MARGIN = 16
	const INSET_BORDER_RADIUS = 12

	return (
		<View
			className="block"
			style={
				inset
					? {
							backgroundColor: theme.colors.card,
							marginHorizontal: INSET_MARGIN,
							borderRadius: INSET_BORDER_RADIUS,
							overflow: "hidden",
						}
					: undefined
			}
		>
			<FlashList
				data={items}
				scrollEnabled={false}
				estimatedItemSize={
					measurements.SIZE + measurements.PADDING_VERTICAL * 2 + measurements.BORDER_SIZE
				}
				renderItem={props =>
					props.item ? (
						<AppListItem
							{...props.item}
							measurements={measurements}
							inset={inset}
							isLast={props.index === items.length - 1}
						/>
					) : (
						<AppListItemShimmer
							measurements={measurements}
							inset={inset}
							isLast={props.index === items.length - 1}
						/>
					)
				}
			/>
		</View>
	)
}
