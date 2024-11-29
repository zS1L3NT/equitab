import { useTheme } from "@react-navigation/native"
import { LinearGradient } from "expo-linear-gradient"
import { Dimensions, View } from "react-native"
import { createShimmerPlaceholder } from "react-native-shimmer-placeholder"
import type { AppListItemExtraProps } from "./list-item"

const ShimmerPlaceholder = createShimmerPlaceholder(LinearGradient)

export default function ListItemShimmer({ measurements, inset, isLast }: AppListItemExtraProps) {
	const theme = useTheme()

	const { SIZE, PADDING_HORIZONTAL, PADDING_VERTICAL, BORDER_SIZE, FLEX_GAP } = measurements
	const HEIGHT = SIZE + PADDING_VERTICAL * 2

	const INSET_MARGIN = 16
	const INSET_BORDER_RADIUS = 12
	const MAX_CONTENT_WIDTH =
		Dimensions.get("screen").width -
		SIZE * 2 -
		PADDING_HORIZONTAL * 2 -
		FLEX_GAP * 4 -
		(inset ? INSET_MARGIN * 2 : 0)

	return (
		<View
			className="relative"
			style={[
				{ height: HEIGHT, backgroundColor: theme.colors.card },
				!isLast
					? {
							height: HEIGHT + BORDER_SIZE,
							borderBottomWidth: BORDER_SIZE,
							borderStyle: "solid",
							borderBottomColor: theme.colors.border,
						}
					: null,
			]}
		>
			{!isLast && (
				<View
					className="absolute left-0 bottom-[-1px] h-[1px]"
					style={{
						width: PADDING_HORIZONTAL + FLEX_GAP + SIZE + FLEX_GAP,
						backgroundColor: theme.colors.card,
					}}
				/>
			)}
			<View
				className="flex flex-row items-center"
				style={{
					height: HEIGHT,
					gap: FLEX_GAP,
					paddingHorizontal: PADDING_HORIZONTAL + FLEX_GAP,
					paddingVertical: PADDING_VERTICAL,
				}}
			>
				<ShimmerPlaceholder
					style={{
						width: SIZE,
						height: SIZE,
						borderRadius: inset ? INSET_BORDER_RADIUS : "50%",
					}}
				/>
				<View className="flex gap-1">
					<ShimmerPlaceholder
						style={{
							width: MAX_CONTENT_WIDTH,
							height: 17,
							borderRadius: 4,
						}}
					/>
					<ShimmerPlaceholder
						style={{
							width: MAX_CONTENT_WIDTH / 2,
							height: 14,
							borderRadius: 4,
						}}
					/>
				</View>
			</View>
		</View>
	)
}
