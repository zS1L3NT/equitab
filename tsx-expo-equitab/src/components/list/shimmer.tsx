import { LinearGradient } from "expo-linear-gradient"
import { Row } from "react-native-ios-list"
import { createShimmerPlaceholder } from "react-native-shimmer-placeholder"
import { LIST_AVATAR_SIZE } from "."

const ShimmerPlaceholder = createShimmerPlaceholder(LinearGradient)

type ListShimmerProps = {
	subtitle?: boolean
	leading?: boolean
}

export default function ListShimmer({ subtitle = false, leading = false }: ListShimmerProps) {
	return (
		<Row
			leading={
				leading ? (
					<ShimmerPlaceholder
						style={{ borderRadius: "50%" }}
						width={LIST_AVATAR_SIZE}
						height={LIST_AVATAR_SIZE}
					/>
				) : null
			}
		>
			<ShimmerPlaceholder height={16} />
			{subtitle && <ShimmerPlaceholder style={{ marginTop: 4 }} height={10} width={80} />}
		</Row>
	)
}
