import { useTheme } from "@react-navigation/native"
import { FlashList } from "@shopify/flash-list"
import { View } from "react-native"
import AppListItem, { type AppListItemProps } from "./list-item"
import AppListItemShimmer from "./list-item-shimmer"
import {
	INSET_LIST_MEASUREMENTS,
	LARGE_INSET_LIST_MEASUREMENTS,
	LARGE_LIST_MEASUREMENTS,
	LIST_MEASUREMENTS,
} from "./measurements"

export type AppListProps = {
	items: (AppListItemProps | null)[]
	large?: boolean
	inset?: boolean
}

export default function AppList({ items, large = false, inset = false }: AppListProps) {
	const theme = useTheme()

	const INSET_MARGIN = 16
	const INSET_BORDER_RADIUS = 12

	const measurements = inset
		? large
			? LARGE_INSET_LIST_MEASUREMENTS
			: INSET_LIST_MEASUREMENTS
		: large
			? LARGE_LIST_MEASUREMENTS
			: LIST_MEASUREMENTS

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
